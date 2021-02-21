import React from "react";
import ControlList from "./ControlList";
import Button from "./../elements/Button";

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

  deleteSection() {
    this.props.onSectionDelete(this.props.data);
  }

  renderInner() {
    if (this.state.open) {
      return (
        <div>
          <Button innerText="Delete" click={() => this.deleteSection()} />
          <ControlList controls={this.props.data.controls} />
        </div>
      );
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
        <div>{this.renderInner()}</div>
      </li>
    );
  }
}
