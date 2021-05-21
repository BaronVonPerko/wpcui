import { Component, MouseEventHandler } from "react";
import React = require("react");
import { FormCancelButton } from "../styled";

interface IProps {
  handleClick: MouseEventHandler;
}
interface IState {}

export default class FormCancel extends Component<IProps, IState> {
  render() {
    return (
      <FormCancelButton
        onClick={this.props.handleClick}
        className="wpcui-form-cancel"
      >
        [Cancel]
      </FormCancelButton>
    );
  }
}
