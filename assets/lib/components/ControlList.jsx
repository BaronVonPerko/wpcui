import React from "react";
import Section from "./Section";
import Control from "./Control";

export default class ControlList extends React.Component {
    render() {
        if(this.props.controls && this.props.controls.length) {
            return this.props.controls.map(control => <Control key={control.id} data={control}/>);
        } else {
            return (
                <p>There are no controls for this section yet.</p>
            )
        }
    }
}