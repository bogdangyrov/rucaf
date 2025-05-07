import sys
import json
import pandas as pd
from statsmodels.tsa.arima.model import ARIMA


def forecast_orders(file_path):
    with open(file_path, "r") as file:
        data = json.load(file)

    dates = [item["date"] for item in data]
    quantities = [item["quantity"] for item in data]

    df = pd.DataFrame({"date": pd.to_datetime(dates), "quantity": quantities})
    df.set_index("date", inplace=True)

    df["quantity"] = pd.to_numeric(df["quantity"], errors="coerce")

    df = df.dropna()

    model = ARIMA(df["quantity"], order=(5, 1, 0))
    model_fit = model.fit()

    forecast = model_fit.forecast(steps=10)

    forecast_result = forecast.tolist()

    print(json.dumps(forecast_result))


if __name__ == "__main__":
    file_path = sys.argv[1]
    forecast_orders(file_path)
