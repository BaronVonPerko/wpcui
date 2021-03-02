import React from "react";

export default class TextInput extends React.Component {
  constructor(props) {
    super(props);

    this.renderLabel = this.renderLabel.bind(this);
  }

  renderLabel() {
    return this.props.label ? (
      <label htmlFor={this.props.inputId}>{this.props.label}</label>
    ) : (
      ""
    );
  }

  render() {
    return (
      <div className="form-group">
        {this.renderLabel()}
        <input
          id={this.props.inputId ? this.props.inputId : ""}
          type="text"
          className="form-control regular-text"
          placeholder={this.props.placeholder}
          onChange={this.props.onChange}
          value={this.props.value}
        />
      </div>
    );
  }
}
