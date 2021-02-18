import React from 'react';
import Button from "./Button";

export default class WarningBar extends React.Component {

    render() {
        return (
            <div className="notice notice-error">
                <h3>{this.props.title}</h3>
                <p>{this.props.innerText}</p>
                <p>
                    <Button buttonType="secondary"
                            innerText={this.props.buttonText}
                            click={this.props.buttonClick} />
                </p>
            </div>
        )
    }
}