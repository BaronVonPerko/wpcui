import React from "react";
import store, { actions } from "../redux/wpcuiReducer";

export default class Modal extends React.Component {
  close() {
    store.dispatch({ type: actions.CLOSE_MODAL });
  }

  render() {
    return (
      <div className="wpcui-modal-wrapper">
        <div className="wpcui-modal">{this.props.innerComponent}</div>
      </div>
    );
  }
}
