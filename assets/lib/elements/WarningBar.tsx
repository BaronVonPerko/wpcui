import { Component, MouseEventHandler } from "react";
import React = require("react");
import Button from "./Button";

interface IProps {
  title: string;
  innerText: string;
  buttonText?: string;
  buttonClick?: MouseEventHandler;
}
interface IState {}

export default class WarningBar extends Component<IProps, IState> {
  render() {
    if (!this.props.title || !this.props.innerText) return null;

    return (
      <div className="notice notice-error">
        <h3>{this.props.title}</h3>
        <p>{this.props.innerText}</p>
        {this.props.hasOwnProperty("buttonText") &&
          this.props.hasOwnProperty("buttonClick") && (
            <p>
              <Button
                buttonType="secondary"
                innerText={this.props.buttonText}
                click={this.props.buttonClick}
              />
            </p>
          )}
      </div>
    );
  }
}
