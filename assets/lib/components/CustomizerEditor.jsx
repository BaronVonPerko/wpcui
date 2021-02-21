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
      newSectionTitle: "",
    };

    this.toggleAddNewSection = this.toggleAddNewSection.bind(this);
    this.createNewSection = this.createNewSection.bind(this);
    this.handleSectionTitleChange = this.handleSectionTitleChange.bind(this);
  }

  toggleAddNewSection() {
    this.setState({ addNewSection: !this.state.addNewSection });
  }

  handleSectionTitleChange(event) {
    this.setState({ newSectionTitle: event.target.value });
  }

  createNewSection() {
    this.toggleAddNewSection();
    const newSection = {
      id: "test_id",
      title: this.state.newSectionTitle,
      priority: 99,
      visible: true,
    };

    let data = this.state.data;
    data.sections.push(newSection);
    this.setState({ data });

    saveData(this.state.data);
  }

  renderNewSection() {
    if (this.state.addNewSection) {
      return (
        <div>
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
        <SectionList sections={this.props.data.sections} />
      </div>
    );
  }
}
