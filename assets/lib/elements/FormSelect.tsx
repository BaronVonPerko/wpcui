import { ChangeEventHandler, Component } from "react";
import React = require("react");
import { SelectOption } from "../models/selectOptions";

interface IProps {
  inputId: string;
  label: string;
  onChange: ChangeEventHandler;
  value?: string;
  options: SelectOption[];
}
interface IState {}

export default class FormSelect extends Component<IProps, IState> {
  constructor(props) {
    super(props);

    this.renderLabel = this.renderLabel.bind(this);
    this.renderInput = this.renderInput.bind(this);
  }

  renderLabel() {
    return this.props.label ? (
      <label htmlFor={this.props.inputId}>{this.props.label}</label>
    ) : (
      ""
    );
  }

  renderInput() {
    return (
      <select onChange={this.props.onChange}>{this.getOptionItems()}</select>
    );
  }

  getOptionItems() {
    let items = [];
    this.props.options.forEach((option) =>
      items.push(
        <option key={option.value} value={option.value}>
          {option.text}
        </option>
      )
    );
    return items;
  }

  render() {
    return (
      <tr>
        <th>{this.renderLabel()}</th>
        <td>{this.renderInput()}</td>
      </tr>
    );
  }
}
