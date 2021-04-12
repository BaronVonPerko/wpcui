import { Component } from "react";
import store, { actions } from "../redux/wpcuiReducer";
import { connect } from "react-redux";
import EditSectionForm from "../forms/EditSectionForm";
import { Section as CustomizerSection } from "../models/models";
import React = require("react");
import ItemPanelHeader from "./ItemPanelHeader";

interface IProps {
  data: CustomizerSection;
  selectedSection: CustomizerSection;
}
interface IState {
  editing: boolean;
  visible: boolean;
}

class Section extends Component<IProps, IState> {
  constructor(props) {
    super(props);

    this.state = {
      editing: false,
      visible: this.props.data.visible,
    };

    this.click = this.click.bind(this);
    this.getSectionClasses = this.getSectionClasses.bind(this);
    this.getVisibilityClasses = this.getVisibilityClasses.bind(this);
    this.deleteSection = this.deleteSection.bind(this);
    this.editSection = this.editSection.bind(this);
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

  duplicateSection() {
    // TODO: implement duplicate section
    alert("DUPLICATE SECTION - NOT YET IMPLEMENTED");
  }

  editSection() {
    this.setState({ editing: true });
  }

  toggleVisibility(e) {
    e.stopPropagation();
    store.dispatch({
      type: actions.TOGGLE_SECTION_VISIBILITY,
      sectionId: this.props.data.id,
    });

    this.setState({ visible: !this.state.visible });
  }

  getOpen() {
    return this.props.selectedSection?.id === this.props.data.id;
  }

  getSectionClasses() {
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

  getVisibilityClasses() {
    return `dashicons dashicons-visibility wpcui-visibility ${
      this.state.visible ? "wpcui-is-visible" : "wpcui-is-not-visible"
    }`;
  }

  renderEditSectionForm() {
    if (this.state.editing) {
      return (
        <EditSectionForm
          onClose={() => this.setState({ editing: false })}
          section={this.props.data}
        />
      );
    }
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
      <div className={this.getSectionClasses()}>
        {this.renderEditSectionForm()}
        <ItemPanelHeader
          onDelete={{ title: "Delete Section", function: this.deleteSection }}
          onEdit={{ title: "Edit Section", function: this.editSection }}
          // onDuplicate={{title: "Duplicate Section", function: this.duplicateSection}}
        />

        <div onClick={() => this.click()} className="wpcui-section-contents">
          <div className="wpcui-section-title-section">
            <h3>{this.props.data.title}</h3>
            <i
              onClick={(e) => this.toggleVisibility(e)}
              className={this.getVisibilityClasses()}
            />
          </div>
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
