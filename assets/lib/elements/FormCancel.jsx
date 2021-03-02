import React from "react";

export default class FormCancel extends React.Component {
  render() {
    return (
      <p onClick={this.props.handleClick} className="wpcui-form-cancel">
        [Cancel]
      </p>
    );
  }
}
