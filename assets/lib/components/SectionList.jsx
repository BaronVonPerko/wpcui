import React from "react";
import Section from "./Section";
import { connect } from "react-redux";

class SectionList extends React.Component {
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
