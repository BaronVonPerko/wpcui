import { Component } from "react";
import { Control as CustomizerControl } from "../models/models";
import React = require("react");
import store, { actions } from "../redux/wpcuiReducer";
import CardHeader from "./CardHeader";
import { Card, CardContents } from "./../styled";

interface IProps {
  data: CustomizerControl;
}

export default class Control extends Component<IProps, null> {
  constructor(props) {
    super(props);

    this.delete = this.delete.bind(this);
  }

  delete() {
    let res = confirm(
      `Are you sure that you want to delete the control with ID of ${this.props.data.id}`
    );

    if (res) {
      store.dispatch({
        type: actions.DELETE_CONTROL,
        controlId: this.props.data.id,
      });
    }
  }

  showCode() {
    // TODO: show the example code in a modal
  }

  render() {
    return (
      <Card>
        <CardHeader
          title="Control"
          onDelete={{ title: "Delete Control", function: this.delete }}
          onCode={{ title: "Show Code", function: this.showCode }}
        />
        <CardContents>
          <p className="wpcui-control-title">{this.props.data.label}</p>
          <p>Default Value: {this.props.data.default}</p>
        </CardContents>
      </Card>
    );
  }
}
