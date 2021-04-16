import { Component } from "react";
import { Control as CustomizerControl } from "../models/models";
import React = require("react");
import Button from "../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";
import ItemPanelHeader from "./ItemPanelHeader";

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
      <div className="wpcui-control">
        <ItemPanelHeader
          title="Control"
          onDelete={{ title: "Delete Control", function: this.delete }}
          onCode={{ title: "Show Code", function: this.showCode }}
        />
        <div className="wpcui-section-contents">
          <p className="wpcui-control-title">{this.props.data.title}</p>
        </div>
      </div>
    );
  }
}
