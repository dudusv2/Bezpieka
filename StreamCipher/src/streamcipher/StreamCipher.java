package streamcipher;

import java.util.*;
import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Scanner;


public class StreamCipher {

    static int size = 20;
    static int max;

    public static void main(String[] args) {

        String[][] arrayOfBinaryCrypts = null;

        try {
            arrayOfBinaryCrypts = readInput(size);
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        }

        Coding coding = new Coding();
        int[][] counter = new int[size][max];
        for (int i = 0; i < size; i++) {
            for (int z = 0; z < max; z++) {
                counter[i][z] = 0;
            }
        }

        //Wypelnianie tablicy counter [ilosc kryptogramow][maks ilosc bajtow]
        for (int i = 0; i < arrayOfBinaryCrypts.length; i++) {

            for (int j = 0; j < arrayOfBinaryCrypts.length; j++) {
                if (!(i == j)) {
                    String[] xorResult = coding.encode(arrayOfBinaryCrypts[i], arrayOfBinaryCrypts[j]);

                    for (int k = 0; k < xorResult.length; k++) {
                        //System.out.println(xorResult[k]);
                        if (xorResult[k].startsWith("01")) {
                            counter[i][k]++;
                            counter[j][k]++;
                        }
                    }
                }
            }
        }
        //Zapisywanie bajtow-kandydatow na spacje
        ArrayList<ArrayList<String>> listsOfCandidates = new ArrayList<>();
        for (int i = 0; i < max; i++) {
            listsOfCandidates.add(new ArrayList<>());
        }
        for (int i = 0; i < max; i++) {
            int max2 = 0;
            for (int j = 0; j < size; j++) {
                if (counter[j][i] > max2) {
                    max2 = counter[j][i];
                }
            }
            for (int j = 0; j < size; j++) {
                if (counter[j][i] == max2 && max2 != 0 && arrayOfBinaryCrypts[j].length > i) {
                    listsOfCandidates.get(i).add(arrayOfBinaryCrypts[j][i]);
                }
            }
        }
        //xorowanie kandydatow na spacje ze spacja
        for (int i = 0; i < listsOfCandidates.size(); i++) {
            for (int j = 0; j < listsOfCandidates.get(i).size(); j++) {
                listsOfCandidates.get(i).set(j, coding.encode(listsOfCandidates.get(i).get(j), "00100000"));
            }
        }
        //wybieranie najczestszych kandydatow na klucz
        HashMap<Integer, String> findKey = new HashMap();
        for (int i = 0; i < listsOfCandidates.size(); i++) {
            Map<String, Integer> stringsCount = new HashMap<>();
            for (String s : listsOfCandidates.get(i)) {
                Integer c = stringsCount.get(s);
                if (c == null) {
                    c = 0;
                }
                c++;
                stringsCount.put(s, c);
            }
            Map.Entry<String, Integer> mostRepeated = null;
            for (Map.Entry<String, Integer> e : stringsCount.entrySet()) {
                if (mostRepeated == null || mostRepeated.getValue() < e.getValue()) {
                    mostRepeated = e;
                }
            }
            if (mostRepeated != null) {
                findKey.put(i, mostRepeated.getKey());
            }
        }
        //zbieranie klucza
        String[] key = new String[max];
        for (int i = 0; i < max; i++) {
            key[i] = findKey.get(i);
        }

        //xorowanie klucza z wiadomosciami
        ArrayList<String[]> binaryResults = new ArrayList<>();
        for (int i = 0; i < size; i++) {
            binaryResults.add(new String[arrayOfBinaryCrypts[i].length]);
        }
        for (int i = 0; i < size; i++) {
            for (int g = 0; g < arrayOfBinaryCrypts[i].length; g++) {
                if (key[g] != null) {
                    binaryResults.get(i)[g] = coding.encode(arrayOfBinaryCrypts[i][g], key[g]);
                } else {
                    binaryResults.get(i)[g] = "*";
                }
            }
        }

        //konwertowanie bin na ascii i czytanie wynikow
        System.out.println("Key : " + coding.convertbinToString(key));
        for (int i = 0; i < size; i++) {
            System.out.println("Message " + (i + 1) + " : " + coding.convertbinToString(binaryResults.get(i)) + "\n");
        }

    }

    public static String[][] readInput(int size) throws FileNotFoundException {
        String[] txtArray = new String[size];
        Scanner sc;
        String txt;
        int i = 0;
        sc = new Scanner(new File("/home/jakub/Pulpit/Studia/bezpieka/kryptogram"));
        while (sc.hasNext()) {
            txt = sc.nextLine();
            if (!txt.isEmpty() && !txt.startsWith("kryptogram")) {
                txtArray[i] = txt;
                i++;
            }
        }
        max = 0;
        String[][] c = new String[size][];
        for (int g = 0; g < size; g++) {
            c[g] = new String[((txtArray[g].length() + 1) / 9)];
            if (((txtArray[g].length() + 1) / 9) > max) {
                max = ((txtArray[g].length() + 1) / 9);
            }
        }
        for (int g = 0; g < size; g++) {
            putByteInArray(c[g], txtArray[g]);
        }
        return c;
    }

    public static void putByteInArray(String[] c, String txt) {

        int j = 0;
        
        for (int i = 0; i < txt.length() - 1; i += 9) {
            //   System.out.println(txt.length() + " " + i);
            String output = txt.substring(i, (i + 8));
            c[j] = output;
            j++;
        }
    }

}
