import React from "react";
import Button from "../elements/Button";
import SectionList from "./SectionList";
import NewSectionForm from "../forms/NewSectionForm";
import { connect } from "react-redux";
import ControlList from "./ControlList";
import { hideModal, modal } from "./Modal";

class CustomizerEditor extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      addNewSection: false,
    };

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
          {this.props.selectedSection && (
            <ControlList controls={this.props.data.controls} />
          )}
        </div>
      </div>
    );
  }
}

const mapStateToProps = (state) => ({
  selectedSection: state.selectedSection,
});

export default connect(mapStateToProps)(CustomizerEditor);
