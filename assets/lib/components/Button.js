import React from 'react';

export default class Button extends React.Component {
    getTypeClass() {
        return `button-${this.props.buttonType}`;
    }

    render() {
        return (
            <button className={this.getTypeClass()}>{this.props.innerText}</button>
        )
    }
}