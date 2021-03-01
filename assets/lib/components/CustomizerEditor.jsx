import React from "react";
import Button from "../elements/Button";
import SectionList from "./SectionList";
import Modal from "../elements/Modal";
import NewSectionForm from "../forms/NewSectionForm";
import { connect } from "react-redux";
import store, { actions } from "../redux/wpcuiReducer";

class CustomizerEditor extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      addNewSection: false,
      data: this.props.data,
    };

    this.showNewSectionForm = this.showNewSectionForm.bind(this);
  }

  updateData() {
    this.props.updateData(this.state.data);
  }

  showNewSectionForm() {
    this.setState({ addNewSection: true });
    store.dispatch({ type: actions.OPEN_MODAL });
  }

  renderNewSectionForm() {
    if (this.state.addNewSection && this.props.modalOpen) {
      return <Modal innerComponent={<NewSectionForm />} />;
    }
  }

  render() {
    return (
      <div>
        {this.renderNewSectionForm()}
        <Button
          buttonType="primary"
          innerText="Create New Section"
          click={this.showNewSectionForm}
        />
        <SectionList />
      </div>
    );
  }
}

const mapPropsToState = (state) => ({
  modalOpen: state.modalOpen,
});
export default connect(mapPropsToState)(CustomizerEditor);
