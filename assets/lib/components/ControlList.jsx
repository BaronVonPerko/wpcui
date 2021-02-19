import React from "react";
import Section from "./Section";
import Control from "./Control";

export default class ControlList extends React.Component {
    render() {
        return this.props.controls.map(control => <Control key={control.id} data={control} />);
    }
}