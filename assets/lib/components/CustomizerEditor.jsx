import React from "react";
import Button from "../elements/Button";
import SectionList from "./SectionList";
import store, { actions } from "../redux/wpcuiReducer";

export default class CustomizerEditor extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      addNewSection: false,
      data: this.props.data,
      newSectionId: "",
      newSectionTitle: "",
    };

    this.toggleAddNewSectionFormVisible = this.toggleAddNewSectionFormVisible.bind(
      this
    );
    this.createNewSection = this.createNewSection.bind(this);
    this.handleSectionTitleChange = this.handleSectionTitleChange.bind(this);
    this.handleSectionIdChange = this.handleSectionIdChange.bind(this);
  }

  updateData() {
    this.props.updateData(this.state.data);
  }

  /**
   * Toggles the new section form on and off.  If it is
   * currently on (and being turned off), clear the inputs.
   */
  toggleAddNewSectionFormVisible() {
    const clearInputs = this.state.addNewSection;
    this.setState({
      addNewSection: !this.state.addNewSection,
      newSectionId: clearInputs ? "" : this.state.newSectionId,
      newSectionTitle: clearInputs ? "" : this.state.newSectionTitle,
    });
  }

  handleSectionTitleChange(event) {
    this.setState({ newSectionTitle: event.target.value });
  }

  handleSectionIdChange(event) {
    this.setState({ newSectionId: event.target.value });
  }

  /**
   * Create a new section with the given id and title.
   */
  createNewSection() {
    const newSection = {
      id: this.state.newSectionId,
      title: this.state.newSectionTitle,
      priority: 99,
      visible: true,
    };

    store.dispatch({ type: actions.CREATE_SECTION, section: newSection });

    this.toggleAddNewSectionFormVisible();
  }

  renderNewSectionForm() {
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
          <Button
            innerText="Cancel"
            buttonType="secondary"
            click={this.toggleAddNewSectionFormVisible}
          />
        </div>
      );
    } else {
      return (
        <Button
          buttonType="primary"
          innerText="Create New Section"
          click={this.toggleAddNewSectionFormVisible}
        />
      );
    }
  }

  render() {
    return (
      <div>
        {this.renderNewSectionForm()}
        <SectionList />
      </div>
    );
  }
}
