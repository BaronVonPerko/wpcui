import { ChangeEventHandler, Component } from "react";

interface IProps {
  inputId: string;
  label: string;
  disabled?: boolean;
  placeholder: string;
  onChange: ChangeEventHandler;
  value: string;
}
interface IState {}

export default class FormTextInput extends Component<IProps, IState> {
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
      <input
        id={this.props.inputId ? this.props.inputId : ""}
        type="text"
        disabled={this.props.disabled}
        className="form-control regular-text"
        placeholder={this.props.placeholder}
        onChange={this.props.onChange}
        value={this.props.value}
      />
    );
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
