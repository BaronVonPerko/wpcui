import { Component, MouseEventHandler } from "react";

interface IState {}
interface IProps {
  buttonType: string;
  click: MouseEventHandler;
  innerText: string;
}

/**
 * Simple button component.
 *
 * buttonType prop can be either 'primary' or 'secondary'
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
