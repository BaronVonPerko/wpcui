import React from "react";

export default class FormCheckbox extends React.Component {
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
