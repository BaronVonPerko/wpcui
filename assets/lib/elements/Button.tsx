import { Component, MouseEventHandler } from "react";

interface IState {}
interface IProps {
  buttonType?: "primary" | "secondary";
  click: MouseEventHandler;
  innerText: string;
}

/**
 * Simple button component.
 */
export default class Button extends Component<IProps, IState> {
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
