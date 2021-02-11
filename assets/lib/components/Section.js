import React from 'react';
import ControlList from "./ControlList";

export default class Section extends React.Component {
    render() {
        return (
            <div className="wpcui_section">
                <h4>{this.props.data.title}</h4>
                <ControlList controls={this.props.data.controls} />
            </div>
        )
    }
}