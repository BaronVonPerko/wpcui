import { Component } from "react";
import Button from "../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";
import FormTextInput from "../elements/FormTextInput";
import FormCancel from "../elements/FormCancel";
import { stringToSnakeCase } from "../common";
import FormCheckbox from "../elements/FormCheckbox";
import WarningBar from "../elements/WarningBar";
import { Section } from "../models/models";
import React = require("react");
import { ModalWrapper, ModalContent } from "../styled";

interface IProps {
  section: Section;
  onClose: Function;
}
interface IState {
  sectionId: string;
  newSectionId?: string;
  sectionTitle: string;
  autoGenerateId: "checked" | "";
  errorTitle: string;
  errorMessage: string;
}

export default class EditSectionForm extends Component<IProps, IState> {
  constructor(props) {
    super(props);

    this.state = {
      sectionId: this.props.section.id,
      sectionTitle: this.props.section.title,
      autoGenerateId: "checked",
      errorTitle: "",
      errorMessage: "",
    };

    this.handleSectionTitleChange = this.handleSectionTitleChange.bind(this);
    this.handleSectionIdChange = this.handleSectionIdChange.bind(this);
    this.updateSection = this.updateSection.bind(this);
    this.closeForm = this.closeForm.bind(this);
    this.handleAutoGenerateIdChange = this.handleAutoGenerateIdChange.bind(
      this
    );
  }

  /**
   * Update the section with the values provided in the form.
   */
  updateSection() {
    if (!this.state.sectionId || !this.state.sectionTitle) {
      this.setState({
        errorTitle: "Missing Required Fields",
        errorMessage: "Section Title and ID are required.",
      });
      return;
    }

    const updatedSection = {
      id: this.state.sectionId,
      title: this.state.sectionTitle,
      priority: 99,
      visible: true,
      controls: [],
    };

    store.dispatch({
      type: actions.UPDATE_SECTION,
      oldSectionId: this.props.section.id,
      updatedSection,
    });

    this.closeForm();
  }

  closeForm() {
    this.props.onClose();
  }

  handleSectionTitleChange(event) {
    this.setState({ sectionTitle: event.target.value });

    if (this.state.autoGenerateId) {
      this.setState({ sectionId: stringToSnakeCase(event.target.value) });
    }
  }

  handleSectionIdChange(event) {
    this.setState({ sectionId: event.target.value });
  }

  handleAutoGenerateIdChange() {
    if (!this.state.autoGenerateId) {
      this.setState({
        newSectionId: stringToSnakeCase(this.state.sectionTitle),
      });
    }

    this.setState({
      autoGenerateId: this.state.autoGenerateId == "checked" ? "" : "checked",
    });
  }

  render() {
    return (
      <ModalWrapper>
        <ModalContent>
          <h3>Edit Customizer Section</h3>
          <WarningBar
            title={this.state.errorTitle}
            innerText={this.state.errorMessage}
          />
          <table className="form-table">
            <tbody>
              <FormTextInput
                label="Section Title"
                inputId="sectionTitle"
                placeholder="Section Name"
                onChange={this.handleSectionTitleChange}
                value={this.state.sectionTitle}
              />
              <FormCheckbox
                label="Auto-Generate ID"
                checked={this.state.autoGenerateId == "checked"}
                handleChange={this.handleAutoGenerateIdChange}
              />
              <FormTextInput
                label="Section ID"
                inputId="sectionId"
                placeholder="Section ID"
                onChange={this.handleSectionIdChange}
                value={this.state.sectionId}
                disabled={this.state.autoGenerateId == "checked"}
              />
            </tbody>
          </table>
          <Button
            buttonType="primary"
            innerText="Update Section"
            click={this.updateSection}
          />
          <FormCancel handleClick={this.closeForm} />
        </ModalContent>
      </ModalWrapper>
    );
  }
}
