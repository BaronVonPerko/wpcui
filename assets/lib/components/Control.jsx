import React from "react";
import ControlList from "./ControlList";

export default class Control extends React.Component {
  render() {
    return (
      <div className="wpcui-control">
        <p className="wpcui-control-title">{this.props.data.title}</p>
      </div>
    );
  }
}
