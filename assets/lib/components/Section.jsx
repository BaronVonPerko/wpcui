import React from "react";

import Button from "./../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";
import { connect } from "react-redux";

class Section extends React.Component {
  constructor(props) {
    super(props);

    this.click = this.click.bind(this);
  }

  click() {
    if (!this.getOpen()) {
      store.dispatch({
        type: actions.SELECT_SECTION,
        section: this.props.data,
      });
    } else {
      store.dispatch({ type: actions.CLOSE_SECTION });
    }
  }

  deleteSection() {
    store.dispatch({
      type: actions.DELETE_SECTION,
      sectionId: this.props.data.id,
    });
  }

  getOpen() {
    return this.props.selectedSection?.id === this.props.data.id;
  }

  renderInner() {
    if (this.getOpen()) {
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
          this.getOpen()
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

const mapStateToProps = (state) => ({
  selectedSection: state.selectedSection,
});

export default connect(mapStateToProps)(Section);
