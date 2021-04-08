import { ChangeEventHandler, Component } from "react";

interface IProps {
  label: string;
  checked?: boolean;
  handleChange: ChangeEventHandler;
}

export default class FormCheckbox extends Component<IProps, null> {
  render() {
    return (
      <tr>
        <th>{this.props.label}</th>
        <td>
          <input
            checked={this.props.checked}
            type="checkbox"
            onChange={this.props.handleChange}
          />
        </td>
      </tr>
    );
  }
}
