import { Component } from "react";
import { Control as CustomizerControl } from "../models/models";
import React = require("react");
import store, { actions } from "../redux/wpcuiReducer";
import CardHeader from "./CardHeader";
import { Card, CardContents } from "../styled";
import { GetControlTypeById } from "../models/selectOptions";
import { modal } from "./Modal";
import ControlForm from "../forms/ControlForm";

interface IProps {
  data: CustomizerControl;
}

export default class Control extends Component<IProps, null> {
  constructor(props: IProps) {
    super(props);

    this.delete = this.delete.bind(this);
    this.edit = this.edit.bind(this);
    this.showCode = this.showCode.bind(this);
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

  edit() {
    modal(<ControlForm control={this.props.data} />)
  }

  render() {
    return (
      <Card>
        <CardHeader
          title="Control"
          onDelete={{ title: "Delete Control", function: this.delete }}
          onCode={{ title: "Show Code", function: this.showCode }}
          onEdit={{title: "Edit", function: this.edit}}
        />
        <CardContents>
          <p className="wpcui-control-title">{this.props.data.label}</p>
          <p>Type: {GetControlTypeById(this.props.data.type).text}</p>
          <p>Default Value: {this.props.data.default}</p>
        </CardContents>
      </Card>
    );
  }
}
