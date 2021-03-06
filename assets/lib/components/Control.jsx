import React from "react";
import ControlList from "./ControlList";

export default class Control extends React.Component {
  render() {
    return (
      <div className="wpcui_control">
        <h4>{this.props.data.title}</h4>
      </div>
    );
  }
}
