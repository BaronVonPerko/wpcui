import { Component, MouseEventHandler } from "react";
import React = require("react");

interface IProps {
  buttonType?: "primary" | "secondary";
  click: MouseEventHandler;
  innerText: string;
}

/**
 * Simple button component.
 */
export default class Button extends Component<IProps, null> {
  getTypeClass() {
    return `button-${this.props.buttonType ?? "secondary"}`;
  }

  render() {
    return (
      <button
        onClick={(e) => {
          this.props.click(e);
        }}
        className={this.getTypeClass()}
      >
        {this.props.innerText}
      </button>
    );
  }
}
