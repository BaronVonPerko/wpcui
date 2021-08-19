import { Component } from "react";
import store, { actions } from "../redux/wpcuiReducer";
import { connect } from "react-redux";
import { Section as CustomizerSection } from "../models/models";
import React = require("react");
import CardHeader from "./CardHeader";
import { CardTitleSection, CardStats, CardContents, Card } from "../styled";
import SectionForm from "../forms/SectionForm";
import { modal } from "./Modal";

interface IProps {
  data: CustomizerSection;
  selectedSection: CustomizerSection;
}

interface IState {
  visible: boolean;
}

class Section extends Component<IProps, IState> {
  constructor(props) {
    super(props);

    this.state = {
      visible: this.props.data.visible,
    };

    this.click = this.click.bind(this);
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
    modal(<SectionForm section={this.props.data} />);
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

  getDisabled() {
    return !this.getOpen() && this.props.selectedSection !== null;
  }

  getVisibilityClasses() {
    return `dashicons dashicons-visibility wpcui-visibility ${
      this.state.visible ? "wpcui-is-visible" : "wpcui-is-not-visible"
    }`;
  }

  render() {
    return (
      <Card disabled={this.getDisabled()} selected={this.getOpen()}>
        <CardHeader
          title="Section"
          onDelete={{ title: "Delete Section", function: this.deleteSection }}
          onEdit={{ title: "Edit Section", function: this.editSection }}
          // onDuplicate={{title: "Duplicate Section", function: this.duplicateSection}}
        />

        <CardContents
          onClick={() => this.click()}
          className="wpcui-section-contents"
        >
          <CardTitleSection>
            <h3>{this.props.data.title}</h3>
            <i
              onClick={(e) => this.toggleVisibility(e)}
              className={this.getVisibilityClasses()}
            />
          </CardTitleSection>
          <p>
            ID: <em>{this.props.data.id}</em>
          </p>
          <CardStats>
            <h5>{this.props.data.controls.length}</h5>
            <p>controls</p>
          </CardStats>
        </CardContents>
      </Card>
    );
  }
}

const mapStateToProps = (state) => ({
  selectedSection: state.selectedSection,
});

export default connect(mapStateToProps)(Section);
