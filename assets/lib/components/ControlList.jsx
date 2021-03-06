import React from "react";
import Control from "./Control";
import Button from "../elements/Button";
import NewControlForm from "../forms/NewControlForm";
import { connect } from "react-redux";

class ControlList extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      createControlFormShown: false,
    };

    this.displayCreateControlForm = this.displayCreateControlForm.bind(this);
    this.closeForm = this.closeForm.bind(this);
  }

  displayCreateControlForm(e) {
    this.setState({ createControlFormShown: true });

    e.stopPropagation();
  }

  closeForm() {
    this.setState({ createControlFormShown: false });
  }

  renderControls() {
    if (this.props.controls && this.props.controls.length) {
      return this.props.controls.map((control) => (
        <Control key={control.id} data={control} />
      ));
    } else {
      return <p>There are no controls for this section yet.</p>;
    }
  }

  renderNewControlForm() {
    if (this.state.createControlFormShown) {
      return <NewControlForm onClose={this.closeForm} />;
    }
  }

  render() {
    return (
      <div>
        {this.renderNewControlForm()}
        {this.renderControls()}
        <Button
          innerText="Create New Control"
          click={(e) => this.displayCreateControlForm(e)}
        />
        {this.state.createControlFormShown ?? <p>hello world</p>}
      </div>
    );
  }
}

const mapStateToProps = (state) => ({
  controls: state.selectedSection.controls,
});
export default connect(mapStateToProps)(ControlList);
