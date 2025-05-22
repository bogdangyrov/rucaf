import json
import sys
import pandas as pd
import numpy as np
from pmdarima import auto_arima
from sklearn.metrics import mean_absolute_error, mean_squared_error


def load_data(file_path):
    with open(file_path, 'r') as file:
        data = json.load(file)

    months = [item['month'] for item in data]
    quantities = [item['quantity'] for item in data]

    df = pd.DataFrame({'month': pd.to_datetime(months), 'quantity': quantities})
    df.set_index('month', inplace=True)
    df = df.asfreq('MS')
    df['quantity'] = pd.to_numeric(df['quantity'], errors='coerce').fillna(0)

    return df


def remove_outliers_iqr(df: pd.DataFrame) -> pd.DataFrame:
    q1 = df["quantity"].quantile(0.25)
    q3 = df["quantity"].quantile(0.75)
    iqr = q3 - q1
    lower_bound = q1 - 1.5 * iqr
    upper_bound = q3 + 1.5 * iqr
    df["quantity"] = df["quantity"].clip(lower=lower_bound, upper=upper_bound)
    return df


def rolling_forecast_evaluation(series, initial_train_size, forecast_horizon):
    actuals = []
    forecasts = []

    for i in range(initial_train_size, len(series) - forecast_horizon + 1):
        train = series[:i]
        test = series[i:i+forecast_horizon]

        try:
            model = auto_arima(train, seasonal=True, m=12, stepwise=True, suppress_warnings=True, error_action="ignore")
            forecast = model.predict(n_periods=forecast_horizon)
            forecasts.extend(forecast)
            actuals.extend(test[:forecast_horizon])
        except Exception:
            continue

    return np.array(actuals), np.array(forecasts)


def calculate_metrics(actual, forecast):
    mae = mean_absolute_error(actual, forecast)
    rmse = np.sqrt(mean_squared_error(actual, forecast))
    mape = np.mean(np.abs((actual - forecast) / (actual + 1e-10))) * 100  # избегаем деления на 0
    return {
        'MAE': round(mae, 2),
        'RMSE': round(rmse, 2),
        'MAPE': round(mape, 2)
    }


def main(file_path):
    df = load_data(file_path)
    df = remove_outliers_iqr(df)
    series = df['quantity']

    if len(series.dropna()) < 24:
        print("Недостаточно данных для оценки.")
        return

    initial_train_size = 12
    forecast_horizon = 1

    actual, forecast = rolling_forecast_evaluation(series, initial_train_size, forecast_horizon)
    metrics = calculate_metrics(actual, forecast)

    print(json.dumps(metrics, indent=4))


if __name__ == '__main__':
    if len(sys.argv) < 2:
        print("Usage: python accuracy_test.py path_to_json")
        sys.exit(1)

    main(sys.argv[1])
