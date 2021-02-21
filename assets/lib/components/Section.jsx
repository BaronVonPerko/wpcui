import React from "react";
import ControlList from "./ControlList";

export default class Section extends React.Component {
  constructor(props) {
    super(props);

    this.click = this.click.bind(this);
  }

  state = {
    open: false,
  };

  click() {
    this.setState({ open: !this.state.open });
  }

  renderControls() {
    if (this.state.open) {
      return <ControlList controls={this.props.data.controls} />;
    }
  }

  render() {
    return (
      <li
        onClick={this.click}
        className={
          this.state.open
            ? "wpcui-section"
            : "wpcui-section wpcui-section-closed"
        }
      >
        <h3>{this.props.data.title}</h3>
        <div>{this.renderControls()}</div>
      </li>
    );
  }
}
