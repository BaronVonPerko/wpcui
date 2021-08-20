import FormTextInput from "../elements/FormTextInput";
import { DatabaseObject } from "../models/models";
import useControlPrefixForm from "../hooks/useControlPrefixForm";
import { connect } from "react-redux";
import React = require("react");
import Button from "../elements/Button";

interface IProps {
  data: DatabaseObject;
}

const ControlPrefixForm = (props: IProps) => {

  const { controlPrefixChange, controlPrefix, save } = useControlPrefixForm(props.data);

  return (
    <>
      <h3>Control Auto Prefix</h3>
      <p>Use this form to set an automated prefix to all control IDs</p>
      <p><strong>Please Note:</strong> This will change the ID used by your code as well as the customizer. Any data
        that is currently saved in the customizer will be missing when you change the prefix, as it is still saved to
        the old id.</p>

      <table className="form-table">
        <tbody>
        <FormTextInput
          label="Control Prefix"
          inputId="controlPrefix"
          placeholder="Specify a prefix"
          onChange={controlPrefixChange}
          value={controlPrefix}
        />
        </tbody>
      </table>
      <Button
        buttonType="primary"
        innerText={"Save"}
        click={save}
      />
    </>
  );
}


const mapStateToProps = (state) => ({
  data: state
});
export default connect(mapStateToProps)(ControlPrefixForm);