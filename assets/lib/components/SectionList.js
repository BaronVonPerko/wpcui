import React from "react";
import Section from "./Section";

export default class SectionList extends React.Component {

    getSections() {
        console.log(Object.values(this.props.sections));

        const sections = Object.values(this.props.sections);

        return sections.map(section => <Section key={section.id} data={section}/>);
    }

    render() {
        return (
            <div className="customize-sidebar-outer-content wpcui-section-list">
                <div className="customize-pane-parent">
                    {this.getSections()}
                </div>
            </div>
        )
    }
}