import React from "react";
import ControlList from "./ControlList";
import Button from "./../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";

export default class Section extends React.Component {
  constructor(props) {
    super(props);

    this.click = this.click.bind(this);
  }

  state = {
    open: false,
  };

  click() {
    if (!this.state.open) {
      store.dispatch({
        type: actions.SELECT_SECTION,
        section: this.props.data,
      });
    } else {
      store.dispatch({ type: actions.CLOSE_SECTION });
    }
    this.setState({ open: !this.state.open });
  }

  deleteSection() {
    store.dispatch({
      type: actions.DELETE_SECTION,
      sectionId: this.props.data.id,
    });
  }

  renderInner() {
    if (this.state.open) {
      return (
        <div>
          <Button
            innerText="Delete"
            buttonType="secondary"
            click={() => this.deleteSection()}
          />
          <p>
            ID: <em>{this.props.data.id}</em>
          </p>
        </div>
      );
    }
  }

  render() {
    return (
      <div
        onClick={() => this.click()}
        className={
          this.state.open
            ? "wpcui-section"
            : "wpcui-section wpcui-section-closed"
        }
      >
        <h3>{this.props.data.title}</h3>
        <div>{this.renderInner()}</div>
      </div>
    );
  }
}
