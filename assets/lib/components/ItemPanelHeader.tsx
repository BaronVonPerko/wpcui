import { Component } from "react";
import React = require("react");

interface IconButton {
  function: Function;
  title: string;
}

interface IProps {
  onDuplicate?: IconButton;
  onEdit?: IconButton;
  onDelete?: IconButton;
  onCode?: IconButton;
  title?: string;
}

export default class ItemPanelHeader extends Component<IProps, {}> {
  renderHeaderButtons() {
    const buttons = [];
    if (this.props.onCode) {
      buttons.push(
          <i
              key="codeIcon"
              title={this.props.onCode.title}
              onClick={() => this.props.onCode.function()}
              className="dashicons dashicons-editor-code"
          />
      );
    }
    if (this.props.onDuplicate) {
      buttons.push(
        <i
          key="duplicateIcon"
          title={this.props.onDuplicate.title}
          onClick={() => this.props.onDuplicate.function}
          className="dashicons dashicons-admin-page"
        />
      );
    }
    if (this.props.onEdit) {
      buttons.push(
        <i
          key="editIcon"
          title={this.props.onEdit.title}
          onClick={() => this.props.onEdit.function()}
          className="dashicons dashicons-edit"
        />
      );
    }
    if (this.props.onDelete) {
      buttons.push(
        <i
          key="deleteIcon"
          title={this.props.onDelete.title}
          onClick={() => this.props.onDelete.function()}
          className="dashicons dashicons-trash"
        />
      );
    }

    return buttons;
  }

  render() {
    return (
      <div className="wpcui-section-headerbar">
        <div>{this.props.title}</div>
        <div>{this.renderHeaderButtons()}</div>
      </div>
    );
  }
}
