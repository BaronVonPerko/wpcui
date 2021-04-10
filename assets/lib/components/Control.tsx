import { Component } from "react";
import { Control as CustomizerControl } from "../models/models";
import React = require("react");
import Button from "../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";

interface IProps {
  data: CustomizerControl;
}
export default class Control extends Component<IProps, null> {
  constructor(props) {
    super(props);

    this.delete = this.delete.bind(this);
  }

  delete() {
    var res = confirm(
      `Are you sure that you want to delete the control with ID of ${this.props.data.id}`
    );

    if (res) {
      store.dispatch({
        type: actions.DELETE_CONTROL,
        controlId: this.props.data.id,
      });
    }
  }

  render() {
    return (
      <div className="wpcui-control">
        <p className="wpcui-control-title">{this.props.data.title}</p>
        <div className="wpcui-control-buttons">
          <Button click={this.delete} innerText="Delete" />
        </div>
      </div>
    );
  }
}
