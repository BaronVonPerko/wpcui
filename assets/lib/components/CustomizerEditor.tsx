import { Component } from "react";
import Button from "../elements/Button";
import SectionList from "./SectionList";
import NewSectionForm from "../forms/NewSectionForm";
import { connect } from "react-redux";
import ControlList from "./ControlList";
import { modal } from "./Modal";
import { DatabaseObject, Section } from "../models/models";
import React = require("react");

interface IProps {
  data: DatabaseObject;
}

export default class CustomizerEditor extends Component<IProps, null> {
  constructor(props) {
    super(props);

    this.showNewSectionForm = this.showNewSectionForm.bind(this);
  }

  showNewSectionForm() {
    modal(<NewSectionForm />);
  }

  render() {
    return (
      <div>
        <Button
          buttonType="primary"
          innerText="Create New Section"
          click={this.showNewSectionForm}
        />
        <div className="wpcui-editor-columns">
          <SectionList />
          <ControlList />
        </div>
      </div>
    );
  }
}
