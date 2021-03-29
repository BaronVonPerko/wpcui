import React from "react";
import Control from "./Control";
import Button from "../elements/Button";
import NewControlForm from "../forms/NewControlForm";
import { connect } from "react-redux";
import { modal } from "./Modal";

class ControlList extends React.Component {
  constructor(props) {
    super(props);
  }

  displayCreateControlForm(e) {
    modal(<NewControlForm />);
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

  render() {
    return (
      <div className="wpcui-control-list">
        <div className="wpcui-controllist-headerbar">Controls</div>
        <div className="wpcui-controllist-content">
          {this.renderControls()}
          <Button
            innerText="Create New Control"
            click={(e) => this.displayCreateControlForm(e)}
          />
        </div>
      </div>
    );
  }
}

const mapStateToProps = (state) => ({
  controls: state.selectedSection.controls,
});
export default connect(mapStateToProps)(ControlList);
