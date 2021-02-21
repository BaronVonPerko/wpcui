import React from "react";
import Button from "../elements/Button";
import SectionList from "./SectionList";
import { saveData } from "../services/api";

export default class CustomizerEditor extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      addNewSection: false,
      data: this.props.data,
      newSectionId: "",
      newSectionTitle: "",
    };

    this.toggleAddNewSection = this.toggleAddNewSection.bind(this);
    this.createNewSection = this.createNewSection.bind(this);
    this.handleSectionTitleChange = this.handleSectionTitleChange.bind(this);
    this.handleSectionIdChange = this.handleSectionIdChange.bind(this);
  }

  updateData() {
    this.props.updateData(this.state.data);
  }

  toggleAddNewSection() {
    this.setState({ addNewSection: !this.state.addNewSection });
  }

  handleSectionTitleChange(event) {
    this.setState({ newSectionTitle: event.target.value });
  }

  handleSectionIdChange(event) {
    this.setState({ newSectionId: event.target.value });
  }

  createNewSection() {
    this.toggleAddNewSection();
    const newSection = {
      id: this.state.newSectionId,
      title: this.state.newSectionTitle,
      priority: 99,
      visible: true,
    };

    let data = this.state.data;
    data.sections.push(newSection);
    this.setState({ data });

    saveData(this.state.data);

    this.state.newSectionId = "";
    this.state.newSectionTitle = "";
  }

  deleteSection(sectionToDelete) {
    const sections = this.state.data.sections.filter(
      (section) => section.id !== sectionToDelete.id
    );
    let data = this.state.data;
    data.sections = sections;
    this.setState({ data });

    saveData(this.state.data);
  }

  renderNewSection() {
    if (this.state.addNewSection) {
      return (
        <div>
          <input
            placeholder="New section id"
            value={this.state.newSectionId}
            onChange={this.handleSectionIdChange}
          />
          <input
            placeholder="New section name"
            value={this.state.newSectionTitle}
            onChange={this.handleSectionTitleChange}
          />
          <Button
            buttonType="primary"
            innerText="Create New Section"
            click={this.createNewSection}
          />
        </div>
      );
    } else {
      return (
        <Button
          buttonType="primary"
          innerText="Create New Section"
          click={this.toggleAddNewSection}
        />
      );
    }
  }

  render() {
    return (
      <div>
        {this.renderNewSection()}
        <SectionList
          sections={this.props.data.sections}
          onSectionDelete={(section) => this.deleteSection(section)}
        />
      </div>
    );
  }
}
