import { Component } from "react";
import Control from "./Control";
import Button from "../elements/Button";
import ControlForm from "../forms/ControlForm";
import { connect } from "react-redux";
import { modal } from "./Modal";
import React = require("react");
import { CardListWrapper } from "../styled";
import { Section } from "../models/models";

interface IProps {
  selectedSection: Section;
}

class ControlList extends Component<IProps, null> {
  constructor(props) {
    super(props);
  }

  displayCreateControlForm() {
    modal(<ControlForm />);
  }

  renderControls() {
    const controls = this.props.selectedSection.controls;
    if (controls && controls.length) {
      return controls.map((control) => (
        <Control key={control.id} data={control} />
      ));
    } else {
      return <p>There are no controls for this section yet.</p>;
    }
  }

  render() {
    if (!this.props.selectedSection) {
      return null;
    }

    return (
      <CardListWrapper>
        {this.renderControls()}
        <Button
          innerText="Create New Control"
          click={() => this.displayCreateControlForm()}
        />
      </CardListWrapper>
    );
  }
}

const mapStateToProps = (state): IProps => ({
  selectedSection: state.selectedSection,
});
export default connect(mapStateToProps)(ControlList);
