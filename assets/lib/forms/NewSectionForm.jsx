import React from "react";
import Button from "../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";

export default class NewSectionForm extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      newSectionId: "",
      newSectionTitle: "",
    };

    this.handleSectionTitleChange = this.handleSectionTitleChange.bind(this);
    this.handleSectionIdChange = this.handleSectionIdChange.bind(this);
    this.createNewSection = this.createNewSection.bind(this);
    this.closeForm = this.closeForm.bind(this);
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

    this.closeForm();
  }

  closeForm() {
    this.props.onClose();
  }

  handleSectionTitleChange(event) {
    this.setState({ newSectionTitle: event.target.value });
  }

  handleSectionIdChange(event) {
    this.setState({ newSectionId: event.target.value });
  }

  render() {
    return (
      <div className="wpcui-modal-wrapper">
        <div className="wpcui-modal">
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
            click={this.closeForm}
          />
        </div>
      </div>
    );
  }
}
