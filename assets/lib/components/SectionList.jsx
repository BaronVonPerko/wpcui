import React from "react";
import Section from "./Section";

export default class SectionList extends React.Component {
  deleteSection(section) {
    this.props.onSectionDelete(section);
  }

  getSections() {
    return this.props.sections.map((section) => (
      <Section
        key={section.id}
        data={section}
        onSectionDelete={(section) => this.deleteSection(section)}
      />
    ));
  }

  render() {
    return <div className="wpcui-section-list">{this.getSections()}</div>;
  }
}
