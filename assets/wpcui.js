import React from "react";
import ReactDOM from "react-dom";
import CustomizerUI from "./lib/CustomizerUI";
import { Provider } from "react-redux";
import store from "./lib/redux/wpcuiReducer";

const rootElement = document.getElementById("wpcui-app");
document.addEventListener("DOMContentLoaded", () => {
  ReactDOM.render(
    <Provider store={store}>
      <CustomizerUI />
    </Provider>,
    rootElement
  );
});
