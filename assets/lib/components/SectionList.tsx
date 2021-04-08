import { Component } from "react";
import Section from "./Section";
import { Section as CustomizerSection } from "../models/models";
import { connect } from "react-redux";
import React = require("react");

interface IProps {
  sections: CustomizerSection[];
}

class SectionList extends Component<IProps, null> {
  getSections() {
    return this.props.sections.map((section) => (
      <Section key={section.id} data={section} />
    ));
  }

  render() {
    return <div className="wpcui-section-list">{this.getSections()}</div>;
  }
}

const mapStateToProps = (state) => ({
  sections: state.sections,
});

export default connect(mapStateToProps)(SectionList);
