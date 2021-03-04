import React from "react";
import Button from "./Button";

export default class WarningBar extends React.Component {
  render() {
    if (!this.props.title || !this.props.innerText) return null;

    return (
      <div className="notice notice-error">
        <h3>{this.props.title}</h3>
        <p>{this.props.innerText}</p>
        {(this.props.buttonText !== "" && this.props.buttonClick !== null) ?? (
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
