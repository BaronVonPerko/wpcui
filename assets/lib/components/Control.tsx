import { Component } from "react";
import { Control as CustomizerControl, Settings } from "../models/models";
import React = require("react");
import store, { actions } from "../redux/wpcuiReducer";
import CardHeader from "./CardHeader";
import { Card, CardContents } from "../styled";
import { GetControlTypeById } from "../models/selectOptions";
import { hideModal, modal } from "./Modal";
import ControlForm from "../forms/ControlForm";
import { ModalWrapper, ModalContent, CodeSample, ButtonBar } from "../styled";
import Button from "../elements/Button";
import { getFullControlId } from "../common";

interface IProps {
  control: CustomizerControl;
  settings: Settings;
  prefix: string;
}

export default class Control extends Component<IProps, null> {
  constructor(props: IProps) {
    super(props);

    this.delete = this.delete.bind(this);
    this.edit = this.edit.bind(this);
    this.showCode = this.showCode.bind(this);
  }

  delete() {
    let res = confirm(
      `Are you sure that you want to delete the control with ID of ${this.props.control.id}`
    );

    if (res) {
      store.dispatch({
        type: actions.DELETE_CONTROL,
        controlId: this.props.control.id
      });
    }
  }

  copyCode() {
    // @ts-ignore
    document.getElementById('wpcui_sample_code').select();
    document.execCommand('copy');
    alert('Code copied to your clipboard!');
  }

  showCode() {
    const id = this.props.prefix ? `${this.props.prefix}_${this.props.control.id}` : this.props.control.id;
    const sample = `get_theme_mod( '${id}', '${this.props.control.default ? this.props.control.default : "Default Value"}' )`;
    modal(
      <ModalWrapper>
        <ModalContent>
          <CodeSample>
			      <textarea id="wpcui_sample_code" readOnly value={sample}></textarea>
            <span onClick={() => this.copyCode()} title="Copy code" className="wpcui-copy-icon dashicons dashicons-admin-page"></span>
          </CodeSample>

          <ButtonBar>
            <Button innerText="Close" click={hideModal} />
          </ButtonBar>
        </ModalContent>
      </ModalWrapper>);
  }

  edit() {
    modal(<ControlForm control={this.props.control} />);
  }

  render() {
    return (
      <Card>
        <CardHeader
          title="Control"
          onDelete={{ title: "Delete Control", function: this.delete }}
          onCode={{ title: "Show Code", function: this.showCode }}
          onEdit={{ title: "Edit", function: this.edit }}
        />
        <CardContents>
          <p>Label: <strong>{this.props.control.label}</strong></p>
          <p>Id: <strong>{getFullControlId(this.props.control, this.props.settings)}</strong></p>
          <p>Type: <strong>{GetControlTypeById(this.props.control.type).text}</strong></p>
          <p>Default Value: <strong>{this.props.control.default}</strong></p>
        </CardContents>
      </Card>
    );
  }
}
