import React from "react";
import Section from "./Section";
import Control from "./Control";

export default class ControlList extends React.Component {
    render() {
        console.log(Object.values(this.props.controls));

        const controls = Object.values(this.props.controls);

        return controls.map(control => <Control key={control.id} data={control} />);
    }
}