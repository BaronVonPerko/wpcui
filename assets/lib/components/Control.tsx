import { Component } from "react";
import { Control as CustomizerControl } from "../models/models";
import React = require("react");

interface IProps {
  data: CustomizerControl;
}
export default class Control extends Component<IProps, null> {
  render() {
    return (
      <div className="wpcui-control">
        <p className="wpcui-control-title">{this.props.data.title}</p>
      </div>
    );
  }
}
