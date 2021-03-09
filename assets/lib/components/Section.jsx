import React from "react";

import Button from "./../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";
import { connect } from "react-redux";

class Section extends React.Component {
  constructor(props) {
    super(props);

    this.click = this.click.bind(this);
    this.getClasses = this.getClasses.bind(this);
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
    const res = confirm("Are you sure you want to delete this section?");
    if (res) {
      store.dispatch({
        type: actions.DELETE_SECTION,
        sectionId: this.props.data.id,
      });
    }
  }

  getOpen() {
    return this.props.selectedSection?.id === this.props.data.id;
  }

  getClasses() {
    let classes = "wpcui-section";

    if (!this.getOpen()) {
      classes += " wpcui-section-closed";
    } else {
      classes += " wpcui-section-selected";
    }

    if (!this.getOpen() && this.props.selectedSection !== null) {
      classes += " wpcui-section-not-selected";
    }

    return classes;
  }

  renderInner() {
    if (this.getOpen()) {
      return (
        <div>
          <p>
            ID: <em>{this.props.data.id}</em>
          </p>
        </div>
      );
    }
  }

  render() {
    return (
      <div className={this.getClasses()}>
        <div className="wpcui-section-headerbar">
          <i
            onClick={() => this.deleteSection()}
            className="dashicons dashicons-trash"
          ></i>
        </div>
        <div onClick={() => this.click()} className="wpcui-section-contents">
          <h3>{this.props.data.title}</h3>
          <div>{this.renderInner()}</div>
        </div>
      </div>
    );
  }
}

const mapStateToProps = (state) => ({
  selectedSection: state.selectedSection,
});

export default connect(mapStateToProps)(Section);
