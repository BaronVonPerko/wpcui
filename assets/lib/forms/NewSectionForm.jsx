import React from "react";
import Button from "../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";
import FormTextInput from "../elements/FormTextInput";
import FormCancel from "../elements/FormCancel";
import { stringToSnakeCase } from "../common";
import FormCheckbox from "../elements/FormCheckbox";
import WarningBar from "../elements/WarningBar";

export default class NewSectionForm extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      newSectionId: "",
      newSectionTitle: "",
      autoGenerateId: "checked",
      errorTitle: "",
      errorMessage: "",
    };

    this.handleSectionTitleChange = this.handleSectionTitleChange.bind(this);
    this.handleSectionIdChange = this.handleSectionIdChange.bind(this);
    this.createNewSection = this.createNewSection.bind(this);
    this.closeForm = this.closeForm.bind(this);
    this.handleAutoGenerateIdChange = this.handleAutoGenerateIdChange.bind(
      this
    );
  }

  renderFormField(field) {
    return (
      <FormTextInput
        label={field.label}
        inputId={field.inputId}
        placeholder={field.placeholder}
        onChange={field.onChange}
        value={field.value}
      />
    );
  }

  /**
   * Create a new section with the given id and title.
   */
  createNewSection() {
    if (!this.state.newSectionTitle || !this.state.newSectionId) {
      this.setState({
        errorTitle: "Missing Required Fields",
        errorMessage: "Section Title and ID are required.",
      });
      return;
    }

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

    if (this.state.autoGenerateId) {
      this.setState({ newSectionId: stringToSnakeCase(event.target.value) });
    }
  }

  handleSectionIdChange(event) {
    this.setState({ newSectionId: event.target.value });
  }

  handleAutoGenerateIdChange() {
    if (!this.state.autoGenerateId) {
      this.setState({
        newSectionId: stringToSnakeCase(this.state.newSectionTitle),
      });
    }

    this.setState({ autoGenerateId: !this.state.autoGenerateId });
  }

  render() {
    return (
      <div className="wpcui-modal-wrapper">
        <div className="wpcui-modal">
          <h3>Create a New Customizer Section</h3>
          <WarningBar
            title={this.state.errorTitle}
            innerText={this.state.errorMessage}
          />
          <table className="form-table">
            <tbody>
              <FormTextInput
                label="Section Title"
                inputId="newSectionTitle"
                placeholder="New Section Name"
                onChange={this.handleSectionTitleChange}
                value={this.state.newSectionTitle}
              />
              <FormCheckbox
                label="Auto-Generate ID"
                checked={this.state.autoGenerateId}
                handleChange={this.handleAutoGenerateIdChange}
              />
              <FormTextInput
                label="Section ID"
                inputId="newSectionId"
                placeholder="New Section ID"
                onChange={this.handleSectionIdChange}
                value={this.state.newSectionId}
                disabled={this.state.autoGenerateId}
              />
            </tbody>
          </table>
          <Button
            buttonType="primary"
            innerText="Create New Section"
            click={this.createNewSection}
          />
          <FormCancel handleClick={this.closeForm} />
        </div>
      </div>
    );
  }
}
