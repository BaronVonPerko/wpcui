import React from "react";
import Button from "../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";
import TextInput from "../elements/TextInput";
import FormCancel from "../elements/FormCancel";

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

  renderFormField(field) {
    return (
      <TextInput
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
          <h3>Create a New Customizer Section</h3>
          <table className="form-table">
            <tbody>
              <TextInput
                label="Section ID"
                inputId="newSectionId"
                placeholder="New Section ID"
                onChange={this.handleSectionIdChange}
                value={this.state.newSectionId}
              />
              <TextInput
                label="Section Title"
                inputId="newSectionTitle"
                placeholder="New Section Name"
                onChange={this.handleSectionTitleChange}
                value={this.state.newSectionTitle}
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
