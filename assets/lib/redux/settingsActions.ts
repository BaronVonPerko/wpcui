import { saveData } from "../services/api";
import { notify, messages } from "../components/Notification";
import { ApplicationState, Control } from "../models/models";

export function saveControlPrefix(
  state: ApplicationState,
  controlPrefix: string
): ApplicationState {

  // Create the new State
  const savePrefixState: ApplicationState = {
    ...state,
    settings: {
      controlPrefix,
    }
  };

  // Save to the database
  saveData(savePrefixState).then(() => {
    notify(messages.SAVE_SUCCESS);
  });

  return { ...savePrefixState };
}
