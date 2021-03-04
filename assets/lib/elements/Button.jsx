import React from "react";

/**
 * Simple button component.
 *
 * buttonType prop can be either 'primary' or 'secondary'
 */
export default class Button extends React.Component {
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
