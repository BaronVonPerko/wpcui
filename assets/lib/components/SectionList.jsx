import React from "react";
import Section from "./Section";

export default class SectionList extends React.Component {

    getSections() {
        return this.props.sections.map(section => <Section key={section.id} data={section}/>);
    }

    render() {
        return (
            <div className="wpcui-section-list">
                {this.getSections()}
            </div>
        )
    }
}