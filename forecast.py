import sys
import json
from typing import List
import pandas as pd
from pmdarima import auto_arima


def load_data(file_path: str) -> pd.DataFrame:
    with open(file_path, "r") as file:
        data = json.load(file)

    months = [item["month"] for item in data]
    quantities = [item["quantity"] for item in data]

    df = pd.DataFrame({"month": pd.to_datetime(months), "quantity": quantities})
    df.set_index("month", inplace=True)
    df = df.asfreq("MS")
    df["quantity"] = pd.to_numeric(df["quantity"], errors="coerce").fillna(0)

    return df


def is_valid_series(df: pd.DataFrame) -> bool:
    return len(df.dropna()) >= 12  # хотя бы 1 год для сезонности


def smooth_series(df: pd.DataFrame, window: int = 3) -> pd.DataFrame:
    df["quantity"] = df["quantity"].rolling(window=window, center=True, min_periods=1).mean()
    return df

def remove_outliers_iqr(df: pd.DataFrame) -> pd.DataFrame:
    q1 = df["quantity"].quantile(0.25)
    q3 = df["quantity"].quantile(0.75)
    iqr = q3 - q1
    lower_bound = q1 - 1.5 * iqr
    upper_bound = q3 + 1.5 * iqr
    df["quantity"] = df["quantity"].clip(lower=lower_bound, upper=upper_bound)
    return df


def generate_forecast(series: pd.Series, steps: int) -> List[float]:
    """SARIMA с автоматическим подбором параметров и сезонностью (год = 12 месяцев)."""
    model = auto_arima(
        series,
        seasonal=True,
        m=12,  # сезонность годовая
        stepwise=True,
        suppress_warnings=True,
        error_action="ignore"
    )
    forecast = model.predict(n_periods=steps)
    return forecast.tolist()

def forecast_orders(file_path: str, steps: int) -> None:
    try:
        df = load_data(file_path)

        if not is_valid_series(df):
            print(json.dumps([]))
            return

        df = remove_outliers_iqr(df)

        result = generate_forecast(df["quantity"], steps)
        print(json.dumps(result))

    except Exception:
        print(json.dumps([]))


if __name__ == "__main__":
    if len(sys.argv) < 3:
        print(json.dumps([]))
        sys.exit(1)

    file_path = sys.argv[1]
    steps = int(sys.argv[2])
    forecast_orders(file_path, steps)
