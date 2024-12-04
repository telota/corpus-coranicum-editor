export class Utilities {
  public static randomInt(min: number, max: number): number {
    const range = Math.floor(max) - Math.floor(min);

    return Math.floor(Math.random() * (range + 1)) + Math.floor(min);
  }
}
