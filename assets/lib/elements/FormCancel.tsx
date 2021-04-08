import { Component, MouseEventHandler } from "react";
import React = require("react");

interface IProps {
  handleClick: MouseEventHandler;
}
interface IState {}

export default class FormCancel extends Component<IProps, IState> {
  render() {
    return (
      <p onClick={this.props.handleClick} className="wpcui-form-cancel">
        [Cancel]
      </p>
    );
  }
}
