import React from "react";
import ReactDOM from "react-dom";
import CustomizerUI from "./lib/CustomizerUI";
import { Provider } from "react-redux";
import store from "./lib/redux/wpcuiReducer";

document.addEventListener("DOMContentLoaded", () => {
  const rootElement = document.getElementById("wpcui-app");

  ReactDOM.render(
    <Provider store={store}>
      <CustomizerUI />
    </Provider>,
    rootElement
  );
});
